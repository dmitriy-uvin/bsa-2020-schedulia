import requestService from '../requestService';

const apiEndpoint = '/events';

const scheduledEventService = {
    async getScheduledEvents(
        page,
        sort,
        direction,
        event_types,
        start_date,
        end_date
    ) {
        const response = await requestService.get(apiEndpoint, {
            page,
            sort,
            direction,
            event_types,
            start_date,
            end_date
        });
        return response?.data;
    },

    async getEventEmailsFilter(
            start_date,
            end_date
    ) {
        const response = await requestService.get(apiEndpoint + '/emails', {
            start_date,
            end_date
        });
        return response?.data?.data;
    },
};

export default scheduledEventService;
