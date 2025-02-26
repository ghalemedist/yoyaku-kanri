<script setup>
    import { ref, watch } from 'vue';
    const emit = defineEmits(['editStatus', 'deleteStatus'])
    const props = defineProps({
        junban_status: Object
    })
    // const selectedStatus = ref(0);
    // selectedStatus.value = props.user.junbanstatus_id

    // watch(() => props.user, () => {
    //     selectedStatus.value = props.user.junbanstatus_id
    // })
</script>
<template>
    <td>{{ junban_status.ordering }}</td>
    <td style="width: auto; text-align: center;">{{ junban_status.title }}</td>
    <td style="width: auto; text-align: center;">{{ junban_status.status_category }}</td>
    <td v-if="junban_status.id > 3">
        <a href="" @click.prevent="$emit('editStatus', junban_status)"><i class="fa fa-edit"></i></a>
        <a href="" @click.prevent="$emit('deleteStatus', junban_status)"><i class="fa fa-trash"></i></a>
    </td>
    <td v-else>
        <a v-if="junban_status.id == 2"
        href="" @click.prevent="$emit('editStatus', junban_status)"><i class="fa fa-edit"></i></a>
    </td>
</template>