/** @module constants/storageKeys */

export const STORAGE_KEYS = {
  settings: "matching-emojis-settings",
  results: "matching-emojis-results",
  cookieConsent: "matching-emojis-cookie-consent",
};

export const LEGACY_STORAGE_KEYS = {
  settings: "lab5-settings",
  results: "lab5-results",
};

/**
 * Reads localStorage with optional one-time migration from a legacy key.
 * @param {string} key - Current storage key.
 * @param {string} [legacyKey] - Deprecated key to migrate from.
 * @returns {string|null}
 */
export function readStorageWithMigration(key, legacyKey) {
  let value = localStorage.getItem(key);
  if (value === null && legacyKey) {
    const legacy = localStorage.getItem(legacyKey);
    if (legacy !== null) {
      localStorage.setItem(key, legacy);
      localStorage.removeItem(legacyKey);
      value = legacy;
    }
  }
  return value;
}
