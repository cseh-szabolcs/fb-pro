import {createSlice} from "@reduxjs/toolkit";
import {fetchElementData} from "app/actions/fetchElementData.ts";
import {fetchFixtures} from "app/actions/fetchFixtures.ts";
import type {Main} from "app/types/main";

interface MainState extends Main {
  documentId: string;
  elementsReady: boolean;
  fixturesReady: boolean;
  error: boolean;
}

const initialState: MainState = {
  uuid: '',
  title: '',
  description: '',
  documentId: '',
  elementsReady: false,
  fixturesReady: false,
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
  },
  extraReducers: (builder) => {
    builder.addCase(fetchElementData.fulfilled, (state, {payload}) => {
      state.uuid = payload.form.uuid;
      state.title = payload.form.title;
      state.description = payload.form.description;
      state.documentId = payload.document.uuid;
      state.elementsReady = true;
    });
    builder.addCase(fetchFixtures.fulfilled, (state) => {
      state.elementsReady = true;
    });
    builder.addCase(fetchElementData.rejected, (state) => {
      state.error = true;
    });
    builder.addCase(fetchFixtures.rejected, (state) => {
      state.error = true;
    });
  },
  selectors: {
    selectIsReady: (state) => state.elementsReady && state.fixturesReady,
    selectDocumentId: (state) => state.documentId,
  },
});

export const {
  selectIsReady,
  selectDocumentId,
} = MainSlice.selectors;
