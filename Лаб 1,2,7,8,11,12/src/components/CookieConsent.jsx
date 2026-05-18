import React, { useState } from "react";
import { Link } from "react-router-dom";
import styled from "styled-components";
import { Modal } from "./Modal/Modal.jsx";
import {
  CONSENT_STATUS,
  hasCookieConsentChoice,
  setCookieConsent,
} from "../utils/cookieConsent.js";

const Title = styled.h2`
  margin: 0 0 12px;
  font-size: 1.35rem;
  color: #0f172a;
`;

const Body = styled.div`
  font-size: 15px;
  line-height: 1.6;
  color: #475569;

  a {
    color: #4f46e5;
    font-weight: 600;
    text-decoration: underline;
  }
`;

const Actions = styled.div`
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  margin-top: 24px;
  justify-content: flex-end;
`;

const Button = styled.button`
  border: none;
  border-radius: 999px;
  padding: 12px 22px;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  transition: transform 0.15s ease, box-shadow 0.15s ease;

  &:hover {
    transform: translateY(-1px);
  }

  &:focus-visible {
    outline: 3px solid #6366f1;
    outline-offset: 2px;
  }
`;

const AcceptButton = styled(Button)`
  background: linear-gradient(135deg, #22c55e, #16a34a);
  color: #fff;
  box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35);
`;

const DeclineButton = styled(Button)`
  background: #f1f5f9;
  color: #334155;
  border: 1px solid #cbd5e1;
`;

/**
 * GDPR cookie consent modal shown until the user accepts or declines.
 * @returns {JSX.Element|null}
 */
export const CookieConsent = () => {
  const [visible, setVisible] = useState(() => !hasCookieConsentChoice());

  const handleChoice = (status) => {
    setCookieConsent(status);
    setVisible(false);
  };

  if (!visible) return null;

  return (
    <Modal
      isOpen={visible}
      ariaLabel="Cookie consent"
      className="app-modal--cookie"
      zIndex={3000}
      closeOnBackdrop={false}
    >
      <Title>Cookies & Privacy</Title>
      <Body>
        <p>
          We use essential technical storage (localStorage) to save your game settings, results, and
          cookie preference. No third-party tracking cookies are used.
        </p>
        <p>
          Read our <Link to="/legal/cookies">Cookie Policy</Link> and{" "}
          <Link to="/legal/privacy">Privacy Policy</Link> for details.
        </p>
      </Body>
      <Actions>
        <DeclineButton type="button" onClick={() => handleChoice(CONSENT_STATUS.DECLINED)}>
          Decline
        </DeclineButton>
        <AcceptButton type="button" onClick={() => handleChoice(CONSENT_STATUS.ACCEPTED)}>
          Accept
        </AcceptButton>
      </Actions>
    </Modal>
  );
};
