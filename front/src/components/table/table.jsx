// CustomTable.js
export const CustomTable = ({ title, thead, tbody }) => {
  return (
    <div className="px-4 sm:px-6 lg:px-8">
      <div className="sm:flex sm:items-center">
        <div className="sm:flex-auto">
          <h1 className="text-base font-semibold leading-6 text-gray-900">{title}</h1>
          <p className="mt-2 text-sm text-gray-700">Description de votre tableau ici.</p>
        </div>
        <div className="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
          {/* Vous pouvez ajouter un bouton ici si nécessaire */}
        </div>
      </div>
      <div className="mt-8 flow-root">
        <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div className="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
              <table className="min-w-full divide-y divide-gray-300">
                <thead className="bg-gray-50">{thead}</thead>
                <tbody className="divide-y divide-gray-200 bg-white">{tbody}</tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
