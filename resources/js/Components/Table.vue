<template>
    <table class="w-full text-sm text-left rtl:text-right text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <slot name="tableHead" />
        </thead>
        <tbody>
            <slot name="tableBody" />
        </tbody>
    </table>
</template>
