import { addUser } from "@/api/index.js";
import { useNavigate } from "@tanstack/react-router";

export const AdminCreateUser = () => {
  const navigate = useNavigate();
  const addNewUser = async (e) => {
    e.preventDefault();
    const target = e.target;
    const payload = {
      email: target.email.value,
      password: target.password.value,
      role: target.role.value,
    };
    try {
      const response = await addUser(payload);
      if (response.status === 200) {
        navigate({ to: "admin", from: "/" });
      }
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      <div className="w-3/5 sm:w-4/5 mx-auto mt-20">
        <h1 className="text-center text-xl font-semibold my-10">Ajouter un utilisateur</h1>
        <form
          className="p-8 border border-gray-200 flex flex-col space-y-4"
          onSubmit={(e) => addNewUser(e)}>
          <div className="mb-4">
            <label htmlFor="email" className="block">
              Email address
            </label>
            <input
              name="email"
              type="email"
              className="w-full border border-gray-300 p-2 rounded"
            />
          </div>
          <div className="mb-4">
            <label htmlFor="password" className="block">
              Mot de passe
            </label>
            <input
              name="password"
              type="password"
              className="w-full border border-gray-300 p-2 rounded"
            />
          </div>
          <div className="mb-4">
            <label htmlFor="role" className="block">
              Rôle
            </label>
            <select name={"role"} className="w-full border border-gray-300 p-2 rounded">
              <option value="admin">admin</option>
              <option value="client">client</option>
            </select>
          </div>
          <button
            type="submit"
            className="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            Ajouter
          </button>
        </form>
      </div>
    </>
  );
};
