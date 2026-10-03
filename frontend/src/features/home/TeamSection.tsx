import { useState } from 'react';
import { SectionTitle } from '@/components/ui/SectionTitle';
import { ImageLightbox } from '@/components/ui/ImageLightbox';
import { GithubIcon, LinkedinIcon } from '@/components/ui/BrandIcons';
import type { TeamMember } from '@/types/shared';

interface TeamSectionProps {
  tagline?: string | null;
  title: string;
  text?: string | null;
  members: TeamMember[];
}

function initials(name: string): string {
  return name
    .split(/\s+/)
    .slice(0, 2)
    .map((part) => part.charAt(0).toUpperCase())
    .join('');
}

export function TeamSection({ tagline, title, text, members }: TeamSectionProps) {
  const [lightbox, setLightbox] = useState<{
    src: string;
    alt: string;
    caption: string;
  } | null>(null);

  if (members.length === 0) return null;

  return (
    <section className="team-one section-space">
      <div className="container-site">
        <SectionTitle tagline={tagline} title={title} text={text} />

        <div className="team-one__list">
          {members.slice(0, 8).map((member) => (
            <article className="team-card" key={member.id}>
              <span className="team-card__shape" aria-hidden />

              <div className="team-card__content">
                {(member.linkedin_url || member.github_url) && (
                  <ul className="social-links">
                    {member.linkedin_url && (
                      <li>
                        <a
                          href={member.linkedin_url}
                          target="_blank"
                          rel="noopener noreferrer"
                          aria-label={`${member.name} on LinkedIn`}
                        >
                          <span className="social-links__icon">
                            <LinkedinIcon size={18} />
                          </span>
                        </a>
                      </li>
                    )}
                    {member.github_url && (
                      <li>
                        <a
                          href={member.github_url}
                          target="_blank"
                          rel="noopener noreferrer"
                          aria-label={`${member.name} on GitHub`}
                        >
                          <span className="social-links__icon">
                            <GithubIcon size={18} />
                          </span>
                        </a>
                      </li>
                    )}
                  </ul>
                )}

                <div className="team-card__identity">
                  <h3 className="team-card__name">
                    <span className="team-card__name-stroke">{member.name}</span>
                    <span className="team-card__name-fill" aria-hidden>
                      {member.name}
                    </span>
                  </h3>
                </div>

                <div className="team-card__image">
                  {member.photo?.url ? (
                    <button
                      type="button"
                      className="team-card__photo-btn"
                      onClick={() =>
                        setLightbox({
                          src: member.photo!.url,
                          alt: member.photo!.alt_text || member.name,
                          caption: [member.name, member.position].filter(Boolean).join(' — '),
                        })
                      }
                      aria-label={member.name}
                    >
                      <img
                        src={member.photo.url}
                        alt={member.photo.alt_text || member.name}
                        width={560}
                        height={720}
                        loading="eager"
                        decoding="async"
                        fetchPriority="high"
                      />
                    </button>
                  ) : (
                    <div className="team-card__initials" aria-hidden>
                      {initials(member.name)}
                    </div>
                  )}
                </div>

                <p className="team-card__designation">{member.position}</p>
              </div>
            </article>
          ))}
        </div>
      </div>

      {lightbox && (
        <ImageLightbox
          src={lightbox.src}
          alt={lightbox.alt}
          caption={lightbox.caption}
          onClose={() => setLightbox(null)}
        />
      )}
    </section>
  );
}
