import Overview from "@/components/Dashboard/overview";
import { Metadata } from "next";
import DefaultLayout from "@/components/Layouts/DefaultLayout";

export const metadata: Metadata = {
  title:
    "Vue d'ensemble",
  description: "Vue d'ensemble",
};

export default function Hee3ome() {
  return (
    <>
      <DefaultLayout>
        <Overview />
      </DefaultLayout>
    </>
  );
}
