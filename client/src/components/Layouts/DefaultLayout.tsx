"use client";
import React, { useState, ReactNode } from "react";
import Sidebar from "@/components/Sidebar";
import Header from "@/components/Header";
import JoinForm from "../Sidebar/JoinForm";
import ClubJoinForm from "../Sidebar/ClubJoinForm";
 
export default function DefaultLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [isJoinFormActive, setIsJoinFormActive] = useState(false);
 
   const [isClubFormActive, setIsClubFormActive] = useState(false);
 
  return (
    <>
       <div className="flex">
         <Sidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} setIsJoinFormActive={setIsJoinFormActive} setIsClubFormActive={setIsClubFormActive} />
 
         <div className="relative flex flex-1 flex-col lg:ml-[14.125rem]">
           <Header sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />
 
           <main>
            <div className="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10 ">
              {isJoinFormActive && (
                <JoinForm
                  setIsJoinFormActive={setIsJoinFormActive}
                   playerData={undefined} 
                   onUpdate={undefined} 
                   isEditMode={undefined}                
                />
               )}
  
              {isClubFormActive && (
              
                <ClubJoinForm
                setIsClubFormActive={setIsClubFormActive} clubData={undefined} onUpdate={undefined} isEditMode={undefined}                
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
