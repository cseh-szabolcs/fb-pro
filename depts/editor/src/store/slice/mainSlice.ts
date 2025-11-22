import {createSlice, type PayloadAction} from "@reduxjs/toolkit";
import {fetchData} from "app/store/action/main/fetchData";

export interface Main {
  id: string;
  name: string;
}

interface MainState extends Main {
  ready: boolean;
}

const initialState: MainState = {
  id: '',
  name: '',
  ready: false,
};

export const MainSlice = createSlice({
  name: 'main',
  initialState,
  reducers: {
    update: (state, action: PayloadAction<Partial<Omit<Main, 'id'>>>) => {
      state = {
        ...state,
        ...action.payload,
      };
    },
  },
  extraReducers: (builder) => {
    builder.addCase(fetchData.fulfilled, (state, action) => {
      state.ready = true;
      state.id = action.payload[0].id;
      state.name = action.payload[0].name;
    });
  },
  selectors: {
    selectReady: (state) => state.ready,
  },
});
