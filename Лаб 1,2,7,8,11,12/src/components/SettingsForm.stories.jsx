import { SettingsForm } from "./SettingsForm.jsx";
import { difficultyPresets } from "../state/constants.js";

const defaultSettings = {
  difficulty: "normal",
  pairs: difficultyPresets.normal.pairs,
  flipDelay: 700,
};

const meta = {
  title: "Components/SettingsForm",
  component: SettingsForm,
  tags: ["autodocs"],
  parameters: {
    docs: {
      description: {
        component:
          "Комплексна форма з react-hook-form, Yup-валідацією та пресетами складності.",
      },
    },
  },
  argTypes: {
    initialValues: { control: "object" },
    onSubmit: { action: "submit" },
  },
};

export default meta;

export const Default = {
  args: {
    initialValues: defaultSettings,
  },
};

export const EasyPreset = {
  args: {
    initialValues: {
      difficulty: "easy",
      pairs: difficultyPresets.easy.pairs,
      flipDelay: 900,
    },
  },
};

export const HardPreset = {
  args: {
    initialValues: {
      difficulty: "hard",
      pairs: difficultyPresets.hard.pairs,
      flipDelay: 400,
    },
  },
};
