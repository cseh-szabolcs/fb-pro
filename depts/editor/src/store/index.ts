import {configureStore} from "@reduxjs/toolkit";
import {MainSlice} from "app/store/slice/mainSlice.ts";
import {ElementSlice} from "app/store/slice/elementSlice.ts";
import {FixtureSlice} from "app/store/slice/fixtureSlice.ts";
import {type TypedUseSelectorHook, useDispatch, useSelector} from "react-redux";

export const store = configureStore({
  reducer: {
    main: MainSlice.reducer,
    element: ElementSlice.reducer,
    fixture: FixtureSlice.reducer,
  },
});

export const useAppDispatch = () => useDispatch<typeof store.dispatch>();
export const useAppSelector: TypedUseSelectorHook<ReturnType<typeof store.getState>> = useSelector;
