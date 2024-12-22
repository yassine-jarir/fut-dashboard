import { useState, useEffect } from "react";
import { CgClose } from "react-icons/cg";

export default function JoinForm({
  setIsJoinFormActive,
  playerData,
  onUpdate,
  isEditMode,
}) {
  const [formData, setFormData] = useState({
    name: "",
    age: "",
    position: "",
    club: "",
    pace: "",
    photo_url: "",
    shooting: "",
    passing: "",
    dribbling: "",
    defending: "",
    physical: "",
    nationality: "",
    rating: "",
  });

  useEffect(() => {
    if (playerData && isEditMode) {
      setFormData({
        name: playerData.name || "",
        age: playerData.age || "",
        position: playerData.position || "",
        club: playerData.club_name || "",
        pace: playerData.pace || "",
        photo_url: playerData.photo_url || "",
        shooting: playerData.shooting || "",
        passing: playerData.passing || "",
        dribbling: playerData.dribbling || "",
        defending: playerData.defending || "",
        physical: playerData.physical || "",
        nationality: playerData.nationality_name || "",
        rating: playerData.rating || "",
      });
    }
  }, [playerData, isEditMode]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const payload = {
      ...(isEditMode && { id: playerData.player_id }), // Include ID only for edit mode
      name: formData.name,
      age: parseInt(formData.age),
      position: formData.position,
      club: formData.club,
      photo_url: formData.photo_url,
      nationality: formData.nationality,
      pace: parseInt(formData.pace),
      shooting: parseInt(formData.shooting),
      passing: parseInt(formData.passing),
      dribbling: parseInt(formData.dribbling),
      defending: parseInt(formData.defending),
      physical: parseInt(formData.physical),
      rating: parseInt(formData.rating),
    };

    try {
      const url = isEditMode
        ? `${process.env.NEXT_PUBLIC_SERVER_HOST}/players/${playerData.player_id}`
        : `${process.env.NEXT_PUBLIC_SERVER_HOST}/players`;

      const response = await fetch(url, {
        method: isEditMode ? "PUT" : "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
        },
        body: JSON.stringify(payload),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Failed to save player");
      }

      // Wait for the update to complete
      await onUpdate?.();
      setIsJoinFormActive(false);
    } catch (error) {
      console.error("Error saving player:", error);
      alert(error.message);
    }
  };

  // Input field definitions
  const formFields = [
    { label: "Name", field: "name", type: "text" },
    { label: "Age", field: "age", type: "number" },
    { label: "Position", field: "position", type: "text" },
    { label: "Club", field: "club", type: "text" },
    { label: "Pace", field: "pace", type: "number" },
    { label: "Photo URL", field: "photo_url", type: "text" },
    { label: "Shooting", field: "shooting", type: "number" },
    { label: "Passing", field: "passing", type: "number" },
    { label: "Dribbling", field: "dribbling", type: "number" },
    { label: "Defending", field: "defending", type: "number" },
    { label: "Physical", field: "physical", type: "number" },
    { label: "Nationality", field: "nationality", type: "text" },
    { label: "Rating", field: "rating", type: "number" },
  ];

  return (
    <div className="fixed inset-0 z-[999999] flex items-center justify-center bg-black/20">
      <div className="h-screen w-screen overflow-y-auto bg-white sm:h-[520px] sm:w-[700px] sm:rounded-[40px] lg:w-[900px]">
        <div className="flex h-[100px] w-full items-center justify-between px-10">
          <h2 className="text-xl font-bold">
            {isEditMode ? "Edit Player" : "Add New Player"}
          </h2>
          <button
            onClick={() => setIsJoinFormActive(false)}
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
                onChange={(e) => 
                  setFormData(prev => ({
                    ...prev,
                    [field.field]: e.target.value
                  }))
                }
                className="w-full rounded-full border bg-white px-5 py-2 text-slate-950 outline-[var(--primary-color)]"
                required
              />
            </div>
          ))}

          <div className="flex w-full justify-between gap-10 py-5">
            <button
              type="button"
              onClick={() => setIsJoinFormActive(false)}
              className="h-[40px] w-[130px] rounded-full border border-[var(--primary-color)] bg-transparent text-[var(--primary-color)]"
            >
              Cancel
            </button>
            <button
              type="submit"
              className="h-[40px] w-[130px] rounded-full bg-[var(--primary-color)] text-white"
            >
              {isEditMode ? "Update Player" : "Add Player"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}