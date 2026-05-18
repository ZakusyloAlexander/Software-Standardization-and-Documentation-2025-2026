# Matching Emojis

Браузерна гра «Знайди пару» з емодзі, побудована на React 18 та Redux Toolkit. Проєкт підготовлено до здачі з дисципліни **КОП** (стандартизація та документування ПЗ): GDPR, юридичні документи, Storybook, JSDoc та звіт ліцензій.

## Опис

Користувач обирає ID (або грає як гість), налаштовує складність і грає на полі з картками. Результати та налаштування зберігаються в `localStorage` через Redux slices. Реалізовано cookie-банер, сторінки політик і згенеровану API-документацію.

## Технології

| Категорія | Стек |
|-----------|------|
| UI | React 18, styled-components, CSS |
| Збірка | Vite 5 |
| Стан | Redux Toolkit, React-Redux |
| Маршрутизація | React Router 6 |
| Форми | react-hook-form, Yup |
| Документація | JSDoc + docdash |
| UI-каталог | Storybook 8 |
| Якість | ESLint 9 |

## Швидкий старт

```powershell
cd Lab
npm install
npm run dev
```

Відкрийте **http://localhost:5175/**

## Збірка та production

```powershell
npm run build      # docs + vite build → dist/
npm run start      # preview production на :5175
```

## Структура проєкту

```
Lab/
├── public/docs/          # Згенерована JSDoc-документація
├── src/
│   ├── components/       # UI + Storybook stories
│   ├── hooks/            # useEmojiSession
│   ├── pages/            # Legal routes
│   ├── store/            # Redux slices
│   ├── state/            # Константи
│   ├── styles/           # Глобальні стилі
│   └── utils/            # cookieConsent
├── .storybook/           # Конфіг Storybook
├── docs/                 # (резерв, основний output — public/docs)
├── PRIVACY_POLICY.md
├── EULA.md
├── COOKIE_POLICY.md
├── LICENSE               # MIT
├── licenses.md           # Звіт ліцензій
└── licenses.txt          # Сирий вивід license-checker
```

## Scripts

| Команда | Опис |
|---------|------|
| `npm run dev` | Dev-сервер Vite |
| `npm run build` | JSDoc + production build |
| `npm run start` | Preview зібраного застосунку |
| `npm run lint` | ESLint |
| `npm run docs` | Генерація JSDoc → `public/docs/` |
| `npm run storybook` | Storybook на http://localhost:6006 |
| `npm run build-storybook` | Статичний Storybook |
| `npm run licenses` | Звіт ліцензій залежностей |

## Storybook

Два задокументовані компоненти:

1. **StatsPanel** (базовий) — 3 stories  
2. **SettingsForm** (комплексний) — 3 stories з controls та Docs

```powershell
npm run storybook
```

## Документація API

Після `npm run docs` відкрийте:

- У dev: http://localhost:5175/docs/index.html  
- Локально: `public/docs/index.html`  
- Опис архітектури: `src/ARCHITECTURE.md`

## GDPR та Cookies

- Модальне вікно **Accept / Decline** при першому візиті (`CookieConsent`) з backdrop і блокуванням скролу
- Вибір зберігається в `localStorage` (`matching-emojis-cookie-consent`)
- Сторінки: `/legal/cookies`, `/legal/privacy`, `/legal/eula`
- Тексти: `COOKIE_POLICY.md`, `PRIVACY_POLICY.md`, `EULA.md`

## Deployment

1. `npm run build`
2. Розгорніть вміст `dist/` на статичний хостинг (Netlify, Vercel, GitHub Pages)
3. Переконайтесь, що SPA fallback вказує на `index.html`
4. Для GitHub Pages: `base: '/repo-name/'` у `vite.config.js` за потреби

## Ліцензія

Проєкт поширюється під **[MIT License](./LICENSE)**.

Залежності: див. **[licenses.md](./licenses.md)** та `npm run licenses`.

## Авторство

Вебзастосунок Matching Emojis (React, Redux Toolkit).  
Автор: вкажіть ПІБ та групу перед здачею.

## Корисні посилання

| Ресурс | Шлях |
|--------|------|
| API docs | `/docs/index.html` |
| Privacy | `/legal/privacy` |
| Cookies | `/legal/cookies` |
| EULA | `/legal/eula` |
