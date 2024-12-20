"use client"
import { useState, useEffect } from "react";
import Breadcrumb from "../Breadcrumbs/Breadcrumb";
import { Pencil, Trash2 } from "lucide-react";
import ClubJoinForm from "../Sidebar/ClubJoinForm";

const ClubComponent = () => {
  const [clubs, setClubs] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [isClubFormActive, setIsJoinFormActive] = useState(false);
   const [selectedClub, setSelectedClub] = useState(null);

  useEffect(() => {
    fetchClubs();
  }, []);

  const fetchClubs = async () => {
    try {
      const response = await fetch('http://localhost:8003/clubs');
      if (!response.ok) throw new Error('Network response was not ok');
      const data = await response.json();
      setClubs(data.data || []);
      setLoading(false);
    } catch (error) {
      setError(error.message);
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Are you sure you want to delete this club?')) {
      try {
        const response = await fetch(`http://localhost:8003/clubs/${id}`, {
          method: 'DELETE',
        });
        if (!response.ok) throw new Error('Delete failed');
        fetchClubs();
      } catch (error) {
        console.error('Error deleting club:', error);
        alert('Failed to delete club');
      }
    }
  };

  const handleUpdate = (club) => {
    setSelectedClub(club);
    setIsJoinFormActive(true);
  };

  if (loading) return <div className="flex justify-center items-center h-64">Loading...</div>;
  if (error) return <div className="text-red-500 p-4">Error: {error}</div>;
 
  const isEditMode = selectedClub !== null;

  return (
    <>
      <div className="mx-auto max-w-7xl">
        <Breadcrumb pageName="Gestion Des Clubs" />

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
          {clubs.map((club) => (
            <div 
              key={club.id}
              className="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
            >
              <div className="relative h-48 overflow-hidden bg-gray-100">
                <img 
                  src={club.logo_url || '/api/placeholder/400/320'}
                  alt={club.name}
                  className="w-full h-full object-contain p-4"
                />
              </div>
              
              <div className="p-6">
                <div className="flex justify-between items-center">
                  <div>
                    <h3 className="text-2xl font-bold text-gray-900 dark:text-white">
                      {club.name}
                    </h3>
                    <p className="mt-2 text-gray-600 dark:text-gray-300">
                      {club.league || 'League not specified'}
                    </p>
                  </div>
                  
                  <div className="flex space-x-2">
                    <button
                      onClick={() => handleUpdate(club)}
                      className="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-full transition-colors"
                      aria-label="Edit club"
                    >
                      <Pencil className="w-5 h-5" />
                    </button>
                    <button
                      onClick={() => handleDelete(club.id)}
                      className="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-full transition-colors"
                      aria-label="Delete club"
                    >
                      <Trash2 className="w-5 h-5" />
                    </button>
                  </div>
                </div>

                <div className="mt-4 space-y-2">
                  <p className="text-gray-600 dark:text-gray-300">
                    {club.country || 'Country not specified'}
                  </p>
                  <p className="text-gray-600 dark:text-gray-300">
                    {club.stadium || 'Stadium not specified'}
                  </p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {isClubFormActive && (
        <ClubJoinForm
          setIsJoinFormActive={setIsJoinFormActive}
          clubData={selectedClub}
          onUpdate={fetchClubs}
          isEditMode={isEditMode}  
          formType="clubs"   
        />
      )}
    </>
  );
};

export default ClubComponent;
