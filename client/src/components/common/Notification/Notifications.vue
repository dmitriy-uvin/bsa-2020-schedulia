<template>
    <div>
        <div
            v-for="(notification, key, index) in notifications"
            :key="notification.id"
        >
            <Notification :index="index" :notification="notification" />
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import * as notificationGetters from '@/store/modules/notification/types/getters';
import Notification from './Notification';

export default {
    name: 'Notifications',

    components: {
        Notification
    },

    computed: {
        ...mapGetters('notification', {
            notifications: notificationGetters.GET_NOTIFICATIONS
        })
    }
};
</script>
