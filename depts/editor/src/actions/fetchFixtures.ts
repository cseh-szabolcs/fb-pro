import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";

export const fetchFixtures = createAsyncThunk('fetchFixtures', async () => {
  const response = await xhr.get(`/${window.APP_LOCALE}/editor/fixtures/form`);

  return await response.json() as FixturesData;
});

export interface FixturesData {
  uuid: string;
  type: string;
  role?: string;
  position: number;
  children: FixturesData[];
}

