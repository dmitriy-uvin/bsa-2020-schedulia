import * as types from './types/getters';

export default {
    [types.GET_EVENT_TYPES]: state => state.eventTypes,
    [types.GET_EVENT_TYPE]: state => state.eventType,
    [types.GET_EVENT_TYPE_FORM]: state => state.eventTypeForm
};