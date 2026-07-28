import "./globals.css";

export const metadata = {
  title: "IDMADJ.DZ — Questionnaire Collecte de Contenus",
  description: "Plateforme interactive de collecte de contenus pour le projet IDMADJ.DZ - SMART ACCEL INDUSTRIE 4.0",
};

export default function RootLayout({ children }) {
  return (
    <html lang="fr" dir="ltr">
      <body>{children}</body>
    </html>
  );
}

