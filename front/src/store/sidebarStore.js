import { create } from "zustand";

export const useSidebarStore = create((set) => ({
  isOpen: window.innerWidth >= 768,
  toggleSidebar: () => {
    set((state) => ({ isOpen: !state.isOpen }));
  },
  openSideBar: () => {
    set(() => ({ isOpen: true }));
  },
  closeSideBar: () => {
    set(() => ({ isOpen: false }));
  },
}));
