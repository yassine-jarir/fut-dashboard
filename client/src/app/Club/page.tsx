import ClubComponent from "@/components/ClubComponent";
import { Metadata } from "next";
import DefaultLayout from "@/components/Layouts/DefaultLayout";

export const metadata: Metadata = {
  title: "Club",
 
};

const Club = () => {
  return (
    <DefaultLayout>
      <ClubComponent />
    </DefaultLayout>
  );
};

export default Club;
