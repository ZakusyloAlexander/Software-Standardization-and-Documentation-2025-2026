import React from "react";
import { Link } from "react-router-dom";
import ReactMarkdown from "react-markdown";
import styled from "styled-components";
import { Footer } from "../components/Footer.jsx";

const Shell = styled.main`
  min-height: 100vh;
  padding: 32px 16px 96px;
  max-width: 800px;
  margin: 0 auto;
`;

const Card = styled.article`
  background: #fff;
  border-radius: 24px;
  padding: 40px;
  box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.12);
  line-height: 1.65;

  h1 {
    margin-top: 0;
  }

  h2 {
    margin-top: 1.5em;
    font-size: 1.25rem;
  }

  ul {
    padding-left: 1.25rem;
  }
`;

const BackLink = styled(Link)`
  display: inline-block;
  margin-bottom: 16px;
  color: #4f46e5;
  text-decoration: none;
  font-weight: 600;

  &:hover {
    text-decoration: underline;
  }
`;

const GdprBox = styled.section`
  margin-top: 32px;
  padding: 20px;
  border-radius: 16px;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
`;

/**
 * Renders a markdown legal document with optional GDPR highlight block.
 * @param {Object} props
 * @param {string} props.title
 * @param {string} props.content
 * @param {boolean} [props.showGdpr]
 */
export const LegalPage = ({ title: _title, content, showGdpr = false }) => (
  <Shell>
    <BackLink to="/">← На головну</BackLink>
    <Card>
      <ReactMarkdown>{content}</ReactMarkdown>
      {showGdpr && (
        <GdprBox>
          <h2>GDPR — ваші права (коротко)</h2>
          <ul>
            <li>Право на доступ до даних, збережених у вашому браузері (localStorage).</li>
            <li>Право на видалення — очистіть дані сайту в налаштуваннях браузера.</li>
            <li>Право відкликати згоду на cookies — змініть вибір через банер після очищення cookie-consent.</li>
            <li>Контакт з питань конфіденційності: privacy@matching-emojis.local (навчальний проект).</li>
          </ul>
        </GdprBox>
      )}
    </Card>
    <Footer />
  </Shell>
);
