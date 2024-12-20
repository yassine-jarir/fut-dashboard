import GestionComponent from "@/components/GestionComponent";
import { Metadata } from "next";
import DefaultLayout from "@/components/Layouts/DefaultLayout";

export const metadata: Metadata = {
  title: "Gestion Des Joueurs",
  description:
    "This is Next.js Calender page for TailAdmin  Tailwind CSS Admin Dashboard Template",
};

const CalendarPage = () => {
  return (
    <DefaultLayout>
      <GestionComponent />
    </DefaultLayout>
  );
};

export default CalendarPage;
