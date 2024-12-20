import React, { useState } from "react";
 import { usePathname } from "next/navigation";
 const SidebarDropdown = ({ item,setIsJoinFormActive, setIsClubFormActive }: any) => {
 console.log(item)
  return (
    <>
      <ul className="mb-5.5 mt-4 flex flex-col gap-2.5 pl-6 ">
        {item.map((item: any, index: number) => (
          <li key={index}>
            
          {       item.label == "Formulaire"  ? <button
                    onClick={() => setIsJoinFormActive(true)}
                    className="text-orange">
                    {item.label}
                  </button> :
                     <button
                     onClick={() => setIsClubFormActive(true)}
                     className="text-orange">
                     {item.label}
                   </button> 
                     
                  
                
                }
          </li>
        ))}
 
        
       </ul>
    </>
  );
};

export default SidebarDropdown;
