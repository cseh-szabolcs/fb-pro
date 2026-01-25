import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";

const FIXTURES_PATH = `/${window.APP_LOCALE}/editor/fixtures/${window.DATA_TYPE}`;

export const fetchFixtures = createAsyncThunk('fetchFixtures', async () => {
  const response = await xhr.get(FIXTURES_PATH);

  return await response.json() as FixturesData;
});

export interface FixturesData {
  uuid: string;
  type: string;
  role?: string;
  position: number;
  children: FixturesData[];
}

