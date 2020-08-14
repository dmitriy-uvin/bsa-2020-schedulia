<template>
    <div
        class="event-type-block"
        :class="{ 'disabled-event': isDisabled }"
        :style="{ 'border-bottom': '18px solid ' + borderColor }"
    >
        <div class="action-button text-right">
            <DropDown :eventType="eventType" />
        </div>
        <div class="event-type-content">
            <h3>{{ eventType.name }}</h3>
            <span class="event-type-about"
                >{{ eventType.duration }} min, {{ eventType.type }}
            </span>
        </div>
        <div class="event-type-invitee mt-9 mb-2">
            <Avatar :disabled="isDisabled" :size="24"></Avatar>
        </div>
        <VDivider />
        <div class="event-type-actions row">
            <div class="col-lg-3 col-md-3 col-sm-6 duration text-left">
                <span>/{{ eventType.duration }} min</span>
            </div>
            <div class="col-md-9 col-md-9 col-sm-6 text-right">
                <VBtn
                    class="ma-2"
                    outlined
                    small
                    :color="eventType.color"
                    :disabled="isDisabled"
                >
                    {{ lang.COPY_LINK }}
                    <VIcon right dark>mdi-vector-arrange-below </VIcon>
                </VBtn>
                <VBtn
                    class="ma-2 text-left"
                    fab
                    small
                    :color="eventType.color"
                    :disabled="isDisabled"
                >
                    <VIcon dark>mdi-chevron-down</VIcon>
                </VBtn>
            </div>
        </div>
    </div>
</template>

<script>
import DropDown from '@/components/event-types/all-event-types/DropDown';
import Avatar from '@/components/common/GeneralLayout/Avatar';
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'EventType',
    data: () => ({
        lang: enLang
    }),
    props: {
        eventType: {
            required: true
        }
    },
    components: {
        DropDown,
        Avatar
    },
    computed: {
        isDisabled() {
            return this.eventType.disabled;
        },
        borderColor() {
            if (this.isDisabled) {
                return '#e5e5e5';
            }
            return this.eventType.color;
        }
    }
};
</script>

<style scoped>
.event-type-block {
    background: #fff;
    padding: 15px 20px 0 20px;
    border-radius: 10px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.25);
}
.event-type-block div {
    cursor: pointer;
}
.event-type-about {
    color: #858585;
}
.headline {
    font-size: 12px !important;
}
.duration {
    display: flex;
    justify-content: center;
    align-items: center;
}
.duration span {
    color: var(--v-primary-base);
    font-size: 16px;
}
.disabled-event {
    user-select: none;
}
.disabled-event .event-type-content h3,
.disabled-event .event-type-about,
.disabled-event .event-type-actions .duration span {
    color: #e5e5e5;
}
</style>