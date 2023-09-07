import { useNavigate } from "@tanstack/react-router";

import { signIn } from "@/api/index.js";
import { userStore } from "@/store/userStore.js";

import "./style.css";

export const Login = () => {
  const navigate = useNavigate();
  const { setState } = userStore;

  /**
   *
   * @param {React.SyntheticEvent} e
   * @returns {Promise<void>}
   */
  const login = async (e) => {
    e.preventDefault();
    const target = e.target;
    const email = target.email.value;
    const password = target.password.value;
    const credentials = {
      email,
      password,
    };
    try {
      const response = await signIn(credentials);
      if (response.status === 200 && response.data.user === "admin") {
        setState({ user: response.data.user });
        return navigate({ to: "/admin" });
      } else {
        setState({ user: response.data.user });
        return navigate({ to: "/client" });
      }
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <>
      <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
        <div className="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8">
          <div className="bg-gray-400 px-6 py-12 shadow sm:rounded-lg sm:px-12">
            <img className="mx-auto h-10 w-auto" src="/bitchest_logo.png" alt="Bitchest" />
            <form className="space-y-6" onSubmit={(e) => login(e)} method="POST">
              <div>
                <label htmlFor="email" className="block text-sm font-medium leading-6 text-white">
                  Email
                </label>
                <div className="mt-2">
                  <input
                    id="email"
                    name="email"
                    type="email"
                    autoComplete="email"
                    required
                    className="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  />
                </div>
              </div>

              <div>
                <label
                  htmlFor="password"
                  className="block text-sm font-medium leading-6 text-white">
                  Mot de passe
                </label>
                <div className="mt-2">
                  <input
                    id="password"
                    name="password"
                    type="password"
                    autoComplete="current-password"
                    required
                    className="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  />
                </div>
              </div>

              <div>
                <button
                  type="submit"
                  className="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-green-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  Connexion
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </>
  );
};
