<script setup>
    import { ref, watch } from 'vue';
    const emit = defineEmits(['changeStatus', 'loadModal'])
    const props = defineProps({
        user: Object,
        junban_status: Array
    })
    const selectedStatus = ref(0);
    selectedStatus.value = props.user.junbanstatus_id

    watch(() => props.user, () => {
        selectedStatus.value = props.user.junbanstatus_id
    })
</script>
<template>
    <td>
        <select 
            class="select"
            :class="user.junbanstatus_id?'bg-color-'+user.junbanstatus_id:''"
            v-model="selectedStatus"
            @change="$emit('changeStatus',$event, user.id)"
            >
            <option 
            v-for="status in props.junban_status"
            :value="status.id">{{ status.title }}</option>
        </select>
    </td>
    <td>{{ props.user.format_created_at }}</td>
    <td>{{ props.user.junban_num }}番</td>
    <td>{{ props.user.name }}</td>
    <td>{{ props.user.karute }}</td>
    <td>{{ props.user.has_yoyaku_status }}</td>
</template>