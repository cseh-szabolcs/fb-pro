import {createEntityAdapter, createSlice} from "@reduxjs/toolkit";

export interface Element {
  id: string;
  type: string;
  children: string[];
}

const elementAdapter = createEntityAdapter<Element>();
const elementSelector = elementAdapter.getSelectors();

export const ElementSlice = createSlice({
  name: 'element',
  initialState: elementAdapter.getInitialState(),
  reducers: {
    addElement: elementAdapter.addOne,
    updateElement: elementAdapter.updateOne,
    removeElement: elementAdapter.removeOne,
  },
  selectors: {
    selectAll: elementSelector.selectAll,
    selectById: elementSelector.selectById,
    selectIds: elementSelector.selectIds,
    selectEntities: elementSelector.selectEntities,
    selectTotal: elementSelector.selectTotal,
  }
});
