import { BrowserRouter } from "react-router-dom";
import { CookieConsent } from "./CookieConsent.jsx";
import { CONSENT_STATUS, setCookieConsent } from "../utils/cookieConsent.js";
import { STORAGE_KEYS } from "../constants/storageKeys.js";

const withRouter = (Story) => (
  <BrowserRouter>
    <Story />
  </BrowserRouter>
);

const meta = {
  title: "Components/CookieConsent",
  component: CookieConsent,
  decorators: [withRouter],
  tags: ["autodocs"],
  parameters: {
    docs: {
      description: {
        component: "GDPR cookie consent modal with backdrop, scroll lock, and Accept/Decline actions.",
      },
    },
  },
};

export default meta;

export const FirstVisit = {
  decorators: [
    (Story) => {
      localStorage.removeItem(STORAGE_KEYS.cookieConsent);
      return <Story />;
    },
  ],
};

export const AfterAccept = {
  decorators: [
    (Story) => {
      setCookieConsent(CONSENT_STATUS.ACCEPTED);
      return <Story />;
    },
  ],
  parameters: {
    docs: {
      description: {
        story: "Modal hidden after the user has accepted cookies.",
      },
    },
  },
};
