<template>
    <div>
        <Pagination />
        <VContainer class="container-content pagination">
            <TabsLinkScheduled class="scheduled-tabs" :tabs="tabs">
                <template v-slot:left-side>
                    <DatePickerTab />
                </template>
                <template v-slot:right-side>
                    <FilterButton />
                </template>
            </TabsLinkScheduled>
            <DateRange />
        </VContainer>
    </div>
</template>

<script>
import TabsLinkScheduled from '@/components/tabs/TabsLinkScheduled.vue';
import DateRange from './DateRange/DateRange';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import FilterButton from './FilterButton';
import Pagination from './Pagination';
import { mapGetters } from 'vuex';
import DatePickerTab from './DatePickerTab';

export default {
    name: 'DateRangeScheduledEventsList',

    components: {
        DatePickerTab,
        Pagination,
        FilterButton,
        DateRange,
        TabsLinkScheduled
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        tabs() {
            return [
                {
                    id: 1,
                    title: this.lang.UPCOMING,
                    routeName: 'Upcoming'
                },
                {
                    id: 2,
                    title: this.lang.PAST,
                    routeName: 'Past'
                }
            ];
        }
    }
};
</script>

<style scoped>
.container-content.pagination {
    margin-top: 0;
}

.scheduled-tabs::v-deep .v-tabs-bar {
    height: 87px !important;
}

.scheduled-tabs::v-deep .v-toolbar__content {
    height: 87px !important;
}

.scheduled-tabs::v-deep .v-sheet {
    height: 87px !important;
}
</style>
