# Архітектура Matching Emojis

## Шари

| Шар | Шлях | Призначення |
|-----|------|-------------|
| UI | `src/components/` | Презентаційні компоненти |
| Сторінки | `src/pages/` | Юридичні маршрути |
| Стан | `src/store/` | Redux Toolkit slices |
| Логіка | `src/hooks/` | Ігрова сесія |
| Утиліти | `src/utils/` | GDPR / cookies |

## Потік даних

1. Користувач вводить ID на `/` → маршрут `/users/:userId/settings`.
2. `SettingsForm` оновлює `settingsSlice` → `localStorage`.
3. `GameBoard` + `useEmojiSession` керують колодою карт.
4. Після перемоги `resultsSlice` зберігає статистику.

## Маршрути

- `/` — головна
- `/users/:userId/settings|game|results` — гра
- `/legal/*` — політики та EULA
