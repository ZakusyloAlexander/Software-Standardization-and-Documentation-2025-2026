import React from "react";
import content from "../../COOKIE_POLICY.md?raw";
import { LegalPage } from "./LegalPage.jsx";

export const CookiePolicyRoute = () => (
  <LegalPage title="Політика cookies" content={content} showGdpr />
);
