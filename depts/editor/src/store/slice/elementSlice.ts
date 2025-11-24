import {createEntityAdapter, createSlice, type PayloadAction,} from "@reduxjs/toolkit";
import {fetchData, type ElementData} from "app/actions/fetchData.ts";
import type {Element} from "app/types/element.ts";

const elementAdapter = createEntityAdapter<Element, string>({
  selectId: (element) => element.uuid,
});

const elementSelector = elementAdapter.getSelectors();

export const ElementSlice = createSlice({
  name: 'element',
  initialState: elementAdapter.getInitialState(),
  reducers: {
    addElement: elementAdapter.addOne,
    updateElement: (state, action: PayloadAction<{uuid: string; changes: Partial<Element>}>) => {
      elementAdapter.updateOne(state, { id: action.payload.uuid, changes: action.payload.changes });
    },
    removeElement: elementAdapter.removeOne,
  },
  extraReducers: (builder) => {
    builder.addCase(fetchData.fulfilled, (state, {payload}) => {
      const normalized = normalizeElements(payload.document, {});
      for (const [, element] of Object.entries(normalized)) {
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

function normalizeElements(current: ElementData, state: Record<string, Element>) {
  state[current.uuid] = {
    ...current,
    children: current.children.map(child => child.uuid),
  }

  for (const child of current.children) {
    normalizeElements(child, state);
  }

  return state;
}

export const {
  selectAll,
  selectById,
  selectIds,
  selectEntities,
  selectTotal,
} = ElementSlice.selectors;
