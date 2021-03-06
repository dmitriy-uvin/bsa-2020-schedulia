export default {
    publicEvent: {
        eventTypeId: null,
        inviteeName: null,
        inviteeEmail: null,
        startDate: null,
        timezone: null,
        status: null
    },
    eventType: {
        id: null,
        name: null,
        description: null,
        slug: null,
        color: null,
        duration: null,
        disabled: null,
        timezone: null,
        owner: {
            id: null,
            email: null,
            name: null,
            timezone: null,
            nickname: null,
            avatar: null,
            brandingLogo: null,
            welcomeMessage: null,
            language: null,
            dateFormat: null,
            timeFormat12h: true,
            country: null
        },
        availabilities: [
            {
                type: null,
                startDate: null,
                endDate: null
            }
        ]
    }
};
