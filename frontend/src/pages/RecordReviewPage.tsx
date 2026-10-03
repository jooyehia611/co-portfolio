import { useEffect, useRef, useState, type FormEvent } from 'react';
import { useParams } from 'react-router-dom';
import { AudioLines, Mic, Square, RotateCcw, Send } from 'lucide-react';
import apiClient from '@/api/client';
import { useI18n } from '@/i18n';

type Invite = { client_name: string | null };

export function RecordReviewPage() {
  const { token } = useParams<{ token: string }>();
  const { locale } = useI18n();
  const ar = locale === 'ar';
  const [loading, setLoading] = useState(true);
  const [valid, setValid] = useState(false);
  const [name, setName] = useState('');
  const [title, setTitle] = useState('');
  const [company, setCompany] = useState('');
  const [recording, setRecording] = useState(false);
  const [seconds, setSeconds] = useState(0);
  const [blob, setBlob] = useState<Blob | null>(null);
  const [preview, setPreview] = useState('');
  const [sending, setSending] = useState(false);
  const [done, setDone] = useState(false);
  const [error, setError] = useState('');
  const recorder = useRef<MediaRecorder | null>(null);
  const stream = useRef<MediaStream | null>(null);
  const timer = useRef<ReturnType<typeof setInterval> | null>(null);
  const secondsRef = useRef(0);

  useEffect(() => {
    if (!token) return;
    apiClient.get<{ data: Invite }>(`/voice-reviews/${token}`).then(({ data }) => {
      setName(data.data.client_name || ''); setValid(true);
    }).catch(() => setValid(false)).finally(() => setLoading(false));
  }, [token]);

  useEffect(() => () => {
    if (timer.current) clearInterval(timer.current);
    recorder.current?.state === 'recording' && recorder.current.stop();
    stream.current?.getTracks().forEach((track) => track.stop());
  }, []);

  useEffect(() => {
    if (!blob) { setPreview(''); return; }
    const url = URL.createObjectURL(blob);
    setPreview(url);
    return () => URL.revokeObjectURL(url);
  }, [blob]);

  async function start() {
    setError(''); setBlob(null); setSeconds(0); secondsRef.current = 0;
    if (!navigator.mediaDevices?.getUserMedia || !window.MediaRecorder) {
      setError(ar ? 'المتصفح لا يدعم التسجيل الصوتي. جرّب متصفحًا حديثًا.' : 'Your browser does not support voice recording. Try a modern browser.'); return;
    }
    try {
      const media = await navigator.mediaDevices.getUserMedia({ audio: true });
      stream.current = media;
      const mimeType = ['audio/webm;codecs=opus', 'audio/mp4', 'audio/ogg;codecs=opus'].find((type) => MediaRecorder.isTypeSupported(type));
      const instance = new MediaRecorder(media, mimeType ? { mimeType } : undefined);
      const chunks: BlobPart[] = [];
      instance.ondataavailable = (event) => { if (event.data.size) chunks.push(event.data); };
      instance.onstop = () => {
        setBlob(new Blob(chunks, { type: instance.mimeType || 'audio/webm' }));
        media.getTracks().forEach((track) => track.stop());
        stream.current = null;
        if (timer.current) clearInterval(timer.current);
        setRecording(false);
      };
      instance.start(); recorder.current = instance; setRecording(true);
      timer.current = setInterval(() => {
        secondsRef.current += 1; setSeconds(secondsRef.current);
        if (secondsRef.current >= 120) instance.stop();
      }, 1000);
    } catch {
      setError(ar ? 'تعذّر الوصول إلى الميكروفون. اسمح بالوصول وحاول مرة أخرى.' : 'Microphone access failed. Allow access and try again.');
    }
  }

  async function submit(event: FormEvent) {
    event.preventDefault();
    if (!blob || !token || sending) return;
    setSending(true); setError('');
    const extension = blob.type.includes('mp4') ? 'm4a' : blob.type.includes('ogg') ? 'ogg' : 'webm';
    const form = new FormData();
    form.append('client_name', name.trim()); form.append('client_title', title.trim()); form.append('client_company', company.trim());
    form.append('audio', blob, `review.${extension}`); form.append('audio_duration', String(Math.max(1, seconds)));
    try {
      await apiClient.post(`/voice-reviews/${token}`, form, { headers: { 'Content-Type': undefined } });
      setDone(true);
    } catch (cause) {
      const response = cause as { response?: { data?: { message?: string; errors?: Record<string, string[]> } } };
      setError(Object.values(response.response?.data?.errors || {}).flat()[0] || response.response?.data?.message || (ar ? 'تعذّر إرسال التسجيل. حاول مرة أخرى.' : 'Could not send the recording. Please try again.'));
    } finally { setSending(false); }
  }

  return <section className="record-review"><div className="record-review__card">
    <span className="record-review__eyebrow"><AudioLines size={18} /> {ar ? 'رأيك بصوتك' : 'YOUR VOICE MATTERS'}</span>
    {loading ? <p>{ar ? 'جارٍ تحميل الرابط...' : 'Loading your link...'}</p> : !valid ? <><h1>{ar ? 'الرابط غير متاح' : 'Link unavailable'}</h1><p>{ar ? 'قد يكون الرابط انتهت صلاحيته أو استُخدم بالفعل.' : 'This link may have expired or already been used.'}</p></> : done ? <><h1>{ar ? 'شكرًا لمشاركتك!' : 'Thank you for sharing!'}</h1><p>{ar ? 'وصلنا تسجيلك، وسنراجعه قبل نشره.' : 'Your recording has been received and will be reviewed before publication.'}</p></> : <>
      <h1>{ar ? 'احكيلنا عن تجربتك' : 'Tell us about your experience'}</h1>
      <p>{ar ? 'سجّل رسالة صوتية قصيرة عن تجربتك معنا. التسجيل بحد أقصى دقيقتين، ولن يظهر على الموقع إلا بعد مراجعته.' : 'Record a short message about your experience with us. You have up to two minutes, and we will review it before it appears on our site.'}</p>
      <form onSubmit={submit} className="record-review__form">
        <label>{ar ? 'اسمك' : 'Your name'} <span>*</span><input value={name} onChange={(e) => setName(e.target.value)} maxLength={120} required /></label>
        <div className="record-review__fields"><label>{ar ? 'المسمى الوظيفي (اختياري)' : 'Role (optional)'}<input value={title} onChange={(e) => setTitle(e.target.value)} maxLength={120} /></label><label>{ar ? 'الشركة (اختياري)' : 'Company (optional)'}<input value={company} onChange={(e) => setCompany(e.target.value)} maxLength={120} /></label></div>
        <div className={`record-review__recorder ${recording ? 'is-recording' : ''}`}>
          <div className="record-review__visual"><span/><span/><span/><span/><span/><span/><span/><span/><span/><span/><span/></div>
          <strong>{recording ? (ar ? 'جارٍ التسجيل...' : 'Recording...') : blob ? (ar ? 'التسجيل جاهز' : 'Recording ready') : (ar ? 'جاهز للتسجيل؟' : 'Ready to record?')}</strong>
          <small>{String(Math.floor(seconds / 60)).padStart(2, '0')}:{String(seconds % 60).padStart(2, '0')} / 02:00</small>
          {recording ? <button type="button" onClick={() => recorder.current?.stop()}><Square size={17} fill="currentColor" /> {ar ? 'إيقاف' : 'Stop'}</button> : <button type="button" onClick={start}>{blob ? <RotateCcw size={18} /> : <Mic size={18} />} {blob ? (ar ? 'إعادة التسجيل' : 'Record again') : (ar ? 'ابدأ التسجيل' : 'Start recording')}</button>}
          {preview && <audio controls src={preview} className="record-review__preview" />}
        </div>
        {error && <p className="record-review__error" role="alert">{error}</p>}
        <button className="record-review__submit" type="submit" disabled={!blob || recording || sending}><Send size={18} /> {sending ? (ar ? 'جارٍ الإرسال...' : 'Sending...') : (ar ? 'إرسال التسجيل' : 'Send recording')}</button>
      </form>
    </>}
  </div></section>;
}
