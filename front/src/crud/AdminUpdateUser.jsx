import { useLoader, useNavigate } from "@tanstack/react-router";
import { updateUserById } from "@/api/index.js";

export const AdminUpdateUser = () => {
  /**
   * @typedef {import("./Admin.jsx").User} User
   * @type {User}
   */
  const user = useLoader();
  const navigate = useNavigate();
  const otherRole = user.role === "admin" ? "client" : "admin";

  const modifyUserInfo = async (e) => {
    e.preventDefault();
    const payload = { role: e.target.role.value };
    try {
      const response = await updateUserById(user.id, payload);
      if (response.status === 200) {
        navigate({ to: "admin", from: "/" });
      }
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      <div className="flex items-center justify-center flex-col mt-20">
        <h1 className="my-4 text-xl font-semibold">Modifier un utilisateur</h1>
        <form
          className="p-8 border border-gray-200 flex flex-col space-y-4"
          onSubmit={(e) => modifyUserInfo(e)}>
          <div className="mb-4">
            <label htmlFor="email" className="block">
              Email address
            </label>
            <input
              name="email"
              readOnly={true}
              value={user.email}
              type="email"
              className="w-full border border-gray-300 p-2 rounded"
            />
          </div>
          <div className="mb-4">
            <label htmlFor="role" className="block">
              Rôle
            </label>
            <select name="role" className="w-full border border-gray-300 p-2 rounded">
              <option>{user.role}</option>
              <option>{otherRole}</option>
            </select>
          </div>
          <button
            alt="modification user"
            type="submit"
            className="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            Modifier
          </button>
        </form>
      </div>
    </>
  );
};
