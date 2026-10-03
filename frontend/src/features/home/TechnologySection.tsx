import type { Technology } from '@/types/shared';

interface TechnologySectionProps {
  technologies: Technology[];
}

/* Quiet pill strip between the heavier sections. */
export function TechnologySection({ technologies }: TechnologySectionProps) {
  if (technologies.length === 0) return null;

  return (
    <section className="tech-one">
      <div className="container-site">
        <div className="tech-one__grid">
          {technologies.map((tech) => (
            <span className="tech-one__item" key={tech.id}>
              {tech.logo?.url && <img src={tech.logo.url} alt="" loading="lazy" />}
              {tech.name}
            </span>
          ))}
        </div>
      </div>
    </section>
  );
}
