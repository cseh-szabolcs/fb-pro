import {createEntityAdapter, createSlice, type PayloadAction} from "@reduxjs/toolkit";
import {fetchElementData} from "app/actions/fetchElementData.ts";
import {extractElements} from "app/functions/extractElements.ts";
import type {Element} from "app/types/element.ts";

const elementAdapter = createEntityAdapter<Element, string>({
  selectId: (element) => element.id,
});

const elementSelector = elementAdapter.getSelectors();

export const ElementSlice = createSlice({
  name: 'element',
  initialState: elementAdapter.getInitialState(),
  reducers: {
    addElement: elementAdapter.addOne,
    updateElement: (state, action: PayloadAction<{
      id: string;
      changes: Partial<Element>;
    }>) => {
      elementAdapter.updateOne(state, {
        id: action.payload.id,
        changes: action.payload.changes,
      });
    },
    removeElement: elementAdapter.removeOne,
  },
  extraReducers: (builder) => {
    builder.addCase(fetchElementData.fulfilled, (state, {payload}) => {
      const elements = extractElements(payload.document, {});
      for (const [, element] of Object.entries(elements)) {
        elementAdapter.upsertOne(state, element);
      }
    });
  },
  selectors: {
    selectAll: elementSelector.selectAll,
    selectById: elementSelector.selectById,
    selectIds: elementSelector.selectIds,
    selectEntities: elementSelector.selectEntities,
    selectTotal: elementSelector.selectTotal,
  },
});

export const {
  selectAll,
  selectById,
  selectIds,
  selectEntities,
  selectTotal,
} = ElementSlice.selectors;
