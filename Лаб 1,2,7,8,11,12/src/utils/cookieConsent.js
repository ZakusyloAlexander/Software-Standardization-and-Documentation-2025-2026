import { STORAGE_KEYS } from "../constants/storageKeys.js";

const STORAGE_KEY = STORAGE_KEYS.cookieConsent;

export const CONSENT_STATUS = {
  ACCEPTED: "accepted",
  DECLINED: "declined",
};

export function getCookieConsent() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) return null;
    const parsed = JSON.parse(raw);
    if (parsed?.status === CONSENT_STATUS.ACCEPTED || parsed?.status === CONSENT_STATUS.DECLINED) {
      return parsed;
    }
    return null;
  } catch {
    return null;
  }
}

export function setCookieConsent(status) {
  const record = {
    status,
    updatedAt: new Date().toISOString(),
  };
  localStorage.setItem(STORAGE_KEY, JSON.stringify(record));
  return record;
}

export function hasCookieConsentChoice() {
  return getCookieConsent() !== null;
}
