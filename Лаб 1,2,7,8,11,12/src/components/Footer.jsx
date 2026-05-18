import React from "react";
import { Link } from "react-router-dom";
import styled from "styled-components";

const Wrapper = styled.footer`
  width: 100%;
  text-align: center;
  padding: 16px 0 8px;
  font-size: 13px;
  color: #6b7280;

  a {
    color: #4f46e5;
    text-decoration: none;
    margin: 0 8px;

    &:hover {
      text-decoration: underline;
    }
  }
`;

/**
 * Site footer with legal and documentation links.
 * @returns {JSX.Element}
 */
export const Footer = () => (
  <Wrapper>
    <nav aria-label="Юридична інформація">
      <Link to="/legal/cookies">Cookies</Link>
      <Link to="/legal/privacy">Конфіденційність</Link>
      <Link to="/legal/eula">EULA</Link>
      <a href="/docs/index.html" target="_blank" rel="noreferrer">
        Документація API
      </a>
    </nav>
    <p>© {new Date().getFullYear()} Matching Emojis · MIT License</p>
  </Wrapper>
);
