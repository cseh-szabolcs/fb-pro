import {createSlice} from "@reduxjs/toolkit";
import {fetchData} from "app/actions/fetchData";
import type {Main} from "app/types/main";

interface MainState extends Main {
  documentId: string;
  ready: boolean;
  error: boolean;
}

const initialState: MainState = {
  uuid: '',
  title: '',
  description: '',
  documentId: '',
  ready: false,
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
    builder.addCase(fetchData.fulfilled, (state, {payload}) => {
      state.uuid = payload.form.uuid;
      state.title = payload.form.title;
      state.description = payload.form.description;
      state.documentId = payload.documentElement.uuid;
      state.ready = true;
    });
    builder.addCase(fetchData.rejected, (state) => {
      state.error = true;
    });
  },
  selectors: {
    selectReady: (state) => state.ready,
    selectDocumentId: (state) => state.documentId,
  },
});

export const {
  selectReady,
  selectDocumentId,
} = MainSlice.selectors;
