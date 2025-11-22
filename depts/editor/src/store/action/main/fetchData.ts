import {createAsyncThunk} from "@reduxjs/toolkit";
import xhr from "app/xhr";

export const fetchData = createAsyncThunk('fetchData', async () => {
    const response = await xhr.get(window.DATA_SRC);

    return await response.json();
});
