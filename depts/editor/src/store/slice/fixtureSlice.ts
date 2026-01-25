import {createEntityAdapter, createSlice, type PayloadAction} from "@reduxjs/toolkit";
import {fetchFixtures} from "app/actions/fetchFixtures.ts";
import {extractElements} from "app/functions/extractElements.ts";
import type {Element} from "app/types/element.ts";

const elementAdapter = createEntityAdapter<Element, string>({
  selectId: (element) => element.uuid,
});

const elementSelector = elementAdapter.getSelectors();

export const FixtureSlice = createSlice({
  name: 'fixture',
  initialState: elementAdapter.getInitialState(),
  reducers: {
    addElement: elementAdapter.addOne,
    updateElement: (state, action: PayloadAction<{
      uuid: string;
      changes: Partial<Element>;
    }>) => {
      elementAdapter.updateOne(state, {
        id: action.payload.uuid,
        changes: action.payload.changes,
      });
    },
    removeElement: elementAdapter.removeOne,
  },
  extraReducers: (builder) => {
    builder.addCase(fetchFixtures.fulfilled, (state, {payload}) => {
      const elements = extractElements(payload, {});
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
} = FixtureSlice.selectors;
