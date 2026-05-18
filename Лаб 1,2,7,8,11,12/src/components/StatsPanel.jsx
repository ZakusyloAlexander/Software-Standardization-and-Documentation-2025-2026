import React from "react";

/**
 * Displays a row of statistic cards (label + value pairs).
 * @param {Object} props
 * @param {Array<{ label: string, value: string|number }>} props.items - Metrics to render.
 * @returns {JSX.Element}
 * @example
 * <StatsPanel items={[{ label: "Ходи", value: 12 }, { label: "Час", value: "01:23" }]} />
 */
export const StatsPanel = ({ items }) => (
  <div className="stats">
    {items.map((item) => (
      <article className="stat-card" key={item.label}>
        <p className="stat-card__label">{item.label}</p>
        <p className="stat-card__value">{item.value}</p>
      </article>
    ))}
  </div>
);



