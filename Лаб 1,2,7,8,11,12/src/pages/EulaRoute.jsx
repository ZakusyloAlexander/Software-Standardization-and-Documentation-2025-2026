import React from "react";
import content from "../../EULA.md?raw";
import { LegalPage } from "./LegalPage.jsx";

export const EulaRoute = () => <LegalPage title="EULA" content={content} />;
