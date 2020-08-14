<template>
    <VMenu
        nudge-bottom="30"
        nudge-left="150"
        close-on-click
        :close-on-content-click="false"
    >
        <template v-slot:activator="{ on, attrs }">
            <VBtn icon color="primary" v-bind="attrs" v-on="on">
                <VIcon dark>mdi-dots-horizontal</VIcon>
            </VBtn>
        </template>
        <VList>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-calculator</VIcon>
                    {{ lang.MANAGE_AVAILABILITY }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-pencil</VIcon>
                    {{ lang.EDIT }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-file-outline</VIcon>
                    {{ lang.ADD_INTERNAL_NOTE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-content-copy</VIcon>
                    {{ lang.CLONE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-plus-minus-box</VIcon>
                    {{ lang.SAVE_TO_TEMPLATE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-xml</VIcon>
                    {{ lang.ADD_TO_WEBSITE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-delete</VIcon>
                    <DeleteConfirmDialog :eventType="eventType" />
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <div class="switch-item">
                        <div class="pa-0 ma-0">
                            {{ lang.ON }}/{{ lang.OFF }}
                        </div>
                        <div class="pa-0 ma-0">
                            <VSwitch
                                inset
                                v-model="disabled"
                                @change="onSwitch"
                            ></VSwitch>
                        </div>
                    </div>
                </VListItemTitle>
            </VListItem>
        </VList>
    </VMenu>
</template>

<script>
import * as actions from '@/store/modules/eventTypes/types/actions';
import { mapActions } from 'vuex';
import DeleteConfirmDialog from '@/components/event-types/all-event-types/DeleteConfirmDialog';
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'DropDown',
    components: {
        DeleteConfirmDialog
    },
    data: () => ({
        lang: enLang,
        disabled: '',
        dialog: false
    }),
    props: {
        eventType: {
            required: true
        }
    },
    created() {
        this.disabled = this.eventType.disabled;
    },
    methods: {
        ...mapActions('eventTypes', {
            disableEventType: actions.DISABLE_EVENT_TYPE_BY_ID
        }),
        onSwitch() {
            this.disableEventType({
                id: this.eventType.id,
                disabled: this.disabled
            });
        }
    }
};
</script>

<style scoped>
.v-list-item {
    cursor: pointer;
}
.v-list-item__title a {
    text-decoration: none;
    color: #000;
}
.switch-item {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.switch-item div:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>