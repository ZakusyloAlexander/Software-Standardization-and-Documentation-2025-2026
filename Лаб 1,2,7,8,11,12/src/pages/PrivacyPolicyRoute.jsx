import React from "react";
import content from "../../PRIVACY_POLICY.md?raw";
import { LegalPage } from "./LegalPage.jsx";

export const PrivacyPolicyRoute = () => (
  <LegalPage title="Політика конфіденційності" content={content} showGdpr />
);
