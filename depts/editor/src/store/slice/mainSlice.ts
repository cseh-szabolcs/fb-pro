import {createSlice, type PayloadAction} from "@reduxjs/toolkit";
import {fetchElementData} from "app/actions/fetchElementData.ts";
import {fetchFixtures} from "app/actions/fetchFixtures.ts";
import type {Main} from "app/types/main";

interface MainState extends Main {
  documentId: string;
  activeElementId?: string;
  ready: {
    elements: boolean;
    fixtures: boolean;
  };
  error: boolean;
}

const initialState: MainState = {
  id: '',
  title: '',
  description: '',
  documentId: '',
  ready: {
    elements: false,
    fixtures: false,
  },
  error: false,
};

export const MainSlice = createSlice({
  name: 'main',
  initialState,
  reducers: {
    update: (state, {payload}) => {
      state = {
        ...state,
        ...payload,
      };
    },
    setActiveElementId: (state, {payload = undefined}: PayloadAction<undefined | string>) => {
      state.activeElementId = payload;
    },
  },
  extraReducers: (builder) => {
    builder.addCase(fetchElementData.fulfilled, (state, {payload}) => {
      state.id = payload.form.id;
      state.title = payload.form.title;
      state.description = payload.form.description;
      state.documentId = payload.document.id;
      state.ready.elements = true;
    });
    builder.addCase(fetchFixtures.fulfilled, (state) => {
      state.ready.fixtures = true;
    });
    builder.addCase(fetchElementData.rejected, (state) => {
      state.error = true;
    });
    builder.addCase(fetchFixtures.rejected, (state) => {
      state.error = true;
    });
  },
  selectors: {
    selectIsReady: (state) => state.ready.elements && state.ready.fixtures,
    selectDocumentId: (state) => state.documentId,
    getActiveElementId: (state) => state.activeElementId,
  },
});

export const {
  selectIsReady,
  selectDocumentId,
  getActiveElementId,
} = MainSlice.selectors;


export const {
  setActiveElementId,
} = MainSlice.actions;
