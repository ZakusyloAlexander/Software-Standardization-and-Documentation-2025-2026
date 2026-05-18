import { StatsPanel } from "./StatsPanel.jsx";

const meta = {
  title: "Components/StatsPanel",
  component: StatsPanel,
  tags: ["autodocs"],
  parameters: {
    docs: {
      description: {
        component: "Базовий компонент для відображення метрик гри у вигляді карток.",
      },
    },
  },
  argTypes: {
    items: {
      description: "Масив метрик { label, value }",
      control: "object",
    },
  },
};

export default meta;

export const Default = {
  args: {
    items: [
      { label: "Ходи", value: 8 },
      { label: "Збігів", value: 3 },
      { label: "Час", value: "01:24" },
    ],
  },
};

export const EmptyValues = {
  args: {
    items: [
      { label: "Останній час", value: "--:--" },
      { label: "Останні ходи", value: "--" },
      { label: "Точність", value: "--" },
    ],
  },
};

export const SingleMetric = {
  args: {
    items: [{ label: "Рекорд", value: "00:42" }],
  },
};
