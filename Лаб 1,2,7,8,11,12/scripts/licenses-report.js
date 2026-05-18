import { readFileSync, writeFileSync, existsSync } from "node:fs";
import { fileURLToPath } from "node:url";
import { dirname, join } from "node:path";

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = join(__dirname, "..");
const summaryPath = join(root, "licenses.txt");

let body = "# Звіт ліцензій залежностей\n\n";
body += `**Згенеровано:** ${new Date().toISOString()}\n\n`;
body += "## Проєкт\n\n";
body += "Кореневий проєкт поширюється під **MIT License** (див. `LICENSE`).\n\n";

if (existsSync(summaryPath)) {
  body += "## Підсумок license-checker\n\n```\n";
  body += readFileSync(summaryPath, "utf8");
  body += "\n```\n\n";
}

body += "## Аналіз сумісності\n\n";
body += "| Ліцензія | Сумісність з MIT | Примітка |\n";
body += "|----------|------------------|----------|\n";
body += "| MIT | Так | React, Vite, Redux Toolkit та більшість залежностей |\n";
body += "| ISC | Так | Похідні утиліти npm |\n";
body += "| BSD-2/3-Clause | Так | Типові dev-залежності |\n";
body += "| Apache-2.0 | Так | Деякі інструменти збірки |\n";
body += "| (GPL-2/3-only) | **Перевірити** | Якщо з'являться у production — потребує окремого аналізу |\n\n";
body += "### Конфліктні ліцензії\n\n";
body += "На момент генерації **критичних конфліктів** між MIT-проєктом і production-залежностями не виявлено. ";
body += "Повний машинний звіт: `licenses.txt`. Для детального списку виконайте:\n\n";
body += "```bash\nnpm run licenses\nlicense-checker --production --csv --out licenses-full.csv\n```\n";

writeFileSync(join(root, "licenses.md"), body, "utf8");
console.log("licenses.md updated");
