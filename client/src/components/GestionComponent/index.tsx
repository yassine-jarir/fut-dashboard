"use client"
import { useState, useEffect } from "react";
import Breadcrumb from "../Breadcrumbs/Breadcrumb";
import { Pencil, Trash2 } from "lucide-react";
import JoinForm from "../Sidebar/JoinForm";
 
const GestionComponent = () => {
  const [players, setPlayers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [isJoinFormActive, setIsJoinFormActive] = useState(false);
  const [selectedPlayer, setSelectedPlayer] = useState(null);

  useEffect(() => {
    fetchPlayers();
  }, []);

  const fetchPlayers = async () => {
    try {
      const response = await fetch('http://localhost:8003/players');
      if (!response.ok) throw new Error('Network response was not ok');
      const data = await response.json();
      setPlayers(data.data || []);
      setLoading(false);
    } catch (error) {
      setError(error.message);
      setLoading(false);
    }
  };

  const handleDelete = async (playerId) => {
    if (window.confirm('Are you sure you want to delete this player?')) {
      try {
        const response = await fetch(`http://localhost:8003/players/${playerId}`, {
          method: 'DELETE',
        });
        if (!response.ok) throw new Error('Delete failed');
        fetchPlayers();
      } catch (error) {
        console.error('Error deleting player:', error);
        alert('Failed to delete player');
      }
    }
  };

  const handleUpdate = (player) => {
    setSelectedPlayer(player);
    setIsJoinFormActive(true);
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <>
      <div className="mx-auto max-w-7xl">
        <Breadcrumb pageName="Gestion Des Joueurs" />

        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" className="px-2 py-3">Player Name</th>
                <th scope="col" className="px-2 py-3">Age</th>
                <th scope="col" className="px-2 py-3">Position</th>
                <th scope="col" className="px-2 py-3">Club</th>
                <th scope="col" className="px-2 py-3">Photo</th>
                <th scope="col" className="px-2 py-3">Flag</th>
                <th scope="col" className="px-2 py-3">Pace</th>
                <th scope="col" className="px-2 py-3">Shooting</th>
                <th scope="col" className="px-2 py-3">Dribbling</th>
                <th scope="col" className="px-2 py-3">Defending</th>
                <th scope="col" className="px-2 py-3">Physical</th>
                <th scope="col" className="px-2 py-3">Rating</th>
                <th scope="col" className="px-2 py-3">Actions</th>
              </tr>
            </thead>
            <tbody>
              {players.map((player) => (
                <tr 
                  key={player.player_id}
                  className="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                >
                  <th scope="row" className="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {player.name}
                  </th>
                  <td className="px-2 py-4">{player.age}</td>
                  <td className="px-2 py-4">{player.position}</td>
                  <td className="px-2 py-4">{player.club_name}</td>
                  <td className="px-2 py-4">
                    <img 
                      src={player.photo_url} 
                      alt={player.name} 
                      className="w-10 h-10 rounded-full"
                    />
                  </td>
                  <td className="px-2 py-4">
                    <img 
                      src={player.flag_url} 
                      alt={player.nationality} 
                      className="w-8 h-8"
                    />
                  </td>
                  <td className="px-2 py-4">{player.pace}</td>
                  <td className="px-2 py-4">{player.shooting}</td>
                  <td className="px-2 py-4">{player.dribbling}</td>
                  <td className="px-2 py-4">{player.defending}</td>
                  <td className="px-2 py-4">{player.physical}</td>
                  <td className="px-2 py-4">{player.rating}</td>
                  <td className="px-2 py-4 space-x-2">
                    <button
                      onClick={() => handleUpdate(player)}
                      className="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-100 rounded-full"
                    >
                      <Pencil className="w-5 h-5" />
                    </button>
                    <button
                      onClick={() => handleDelete(player.player_id)}
                      className="p-2 text-red-600 hover:text-red-900 hover:bg-red-100 rounded-full"
                    >
                      <Trash2 className="w-5 h-5" />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

       {isJoinFormActive && (
      <JoinForm
        setIsJoinFormActive={setIsJoinFormActive}
        playerData={selectedPlayer}
        onUpdate={fetchPlayers}
        isEditMode={true}
      />
)}
    </>
  );
};

export default GestionComponent;