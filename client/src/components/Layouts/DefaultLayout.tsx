"use client";
import React, { useState } from "react";
import Sidebar from "@/components/Sidebar";
import Header from "@/components/Header";
import JoinForm from "../Sidebar/JoinForm";
import ClubJoinForm from "../Sidebar/ClubJoinForm";

interface Club {
  club_id: string;
  name: string;
  nationality: string;
  logo_url: string;
  club: string;
}

interface Player {
  player_id: string;
  name: string;
  age: string;
  position: string;
  club_name: string;
  pace: string;
  photo_url: string;
  shooting: string;
  passing: string;
  dribbling: string;
  defending: string;
  physical: string;
  goalkeeping: string;
  flag_url: string;
  nationality: string;
  rating: string;
}

export default function DefaultLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [isJoinFormActive, setIsJoinFormActive] = useState(false);
  const [isClubFormActive, setIsClubFormActive] = useState(false);

  const handleUpdate = async (): Promise<void> => {
    return Promise.resolve();
  };

  return (
    <>
      <div className="flex">
        <Sidebar 
          sidebarOpen={sidebarOpen} 
          setSidebarOpen={setSidebarOpen} 
          setIsJoinFormActive={setIsJoinFormActive}
          setIsClubFormActive={setIsClubFormActive}
        />

        <div className="relative flex flex-1 flex-col lg:ml-[14.125rem]">
          <Header 
            sidebarOpen={sidebarOpen} 
            setSidebarOpen={setSidebarOpen} 
          />

          <main>
            <div className="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
              {isJoinFormActive && (
                <JoinForm
                  setIsJoinFormActive={setIsJoinFormActive}
                  playerData={null}
                  onUpdate={handleUpdate}
                  isEditMode={false}
                />
              )}

              {isClubFormActive && (
                <ClubJoinForm
                  setIsClubFormActive={setIsClubFormActive}
                  clubData={null}
                  onUpdate={handleUpdate}
                  isEditMode={false}
                  formType="clubs"
                />
              )}

              {children}
            </div>
          </main>
        </div>
      </div>
    </>
  );
}