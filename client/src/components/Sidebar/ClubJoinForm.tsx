import { useState, useEffect } from "react";
import { CgClose } from "react-icons/cg";

interface Club {
  club_id: string;
  name: string;
  logo_url: string;
}

interface FormData {
  name: string;
  logo_url: string;
}

interface ClubJoinFormProps {
  setIsClubFormActive: React.Dispatch<React.SetStateAction<boolean>>;
  clubData: Club | null;
  onUpdate: () => Promise<void>;
  isEditMode: boolean;
  formType: string;
}

export default function ClubJoinForm({
  setIsClubFormActive,
  clubData,
  onUpdate,
  isEditMode,
 
}: ClubJoinFormProps) {
  const [formData, setFormData] = useState<FormData>({
    name: "",
    logo_url: "",
 
  });
console.log(clubData)
  useEffect(() => {
    if (clubData && isEditMode) {
      setFormData({
        name: clubData.name,
        logo_url: clubData.logo_url,
       });
    }
  }, [clubData, isEditMode]);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>): Promise<void> => {
    e.preventDefault();

    try {
      const url = isEditMode
        ? `http://localhost:8003/clubs/${clubData?.id}`
        : "http://localhost:8003/clubs";

      const response = await fetch(url, {
        method: isEditMode ? "PUT" : "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });
      console.log(response)
      if (!response.ok) throw new Error("Failed to save club data");

      await onUpdate();
      setIsClubFormActive(false);
    } catch (error) {
      console.error("Error saving club data:", error);
      alert("Failed to save club data");
    }
  };

  const handleInputChange = (field: keyof FormData, value: string): void => {
    setFormData((prev) => ({
      ...prev,
      [field]: value,
    }));
  };

  const formFields = [
    { label: "Club Name", field: "name" as keyof FormData, type: "text" },
     { label: "Flag URL", field: "logo_url" as keyof FormData, type: "text" },
  ];

  return (
    <div className="fixed inset-0 z-[999999] flex items-center justify-center bg-black/20">
      <div className="h-screen w-screen overflow-y-auto bg-white sm:h-[520px] sm:w-[700px] sm:rounded-[40px] lg:w-[900px]">
        <div className="flex h-[100px] w-full items-center justify-end px-10">
          <button
            onClick={() => setIsClubFormActive(false)}
            className="flex h-10 w-10 items-center justify-center rounded-xl bg-[var(--primary-color)] text-white"
          >
            <CgClose className="text-2xl" />
          </button>
        </div>

        <form
          className="flex h-fit w-full flex-wrap items-center justify-center gap-5 p-5 px-5 lg:px-16"
          onSubmit={handleSubmit}
        >
          {formFields.map((field) => (
            <div
              key={field.field}
              className="flex w-[45%] flex-col items-center justify-center gap-1"
            >
              <label className="font-bold text-black-2">{field.label}</label>
              <input
                type={field.type}
                value={formData[field.field]}
                onChange={(e) => handleInputChange(field.field, e.target.value)}
                className="w-full rounded-full border bg-white px-5 py-2 text-slate-950 outline-[var(--primary-color)]"
                required
              />
            </div>
          ))}

          <div className="flex w-full justify-between gap-10 py-5">
            <button
              type="button"
              onClick={() => setIsClubFormActive(false)}
              className="h-[40px] w-[130px] rounded-full border border-[var(--primary-color)] bg-transparent text-[var(--primary-color)]"
            >
              Close
            </button>
            <button
              type="submit"
              className="h-[40px] w-[130px] rounded-full bg-[var(--primary-color)] text-white"
            >
              {isEditMode ? "Update" : "Send"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}