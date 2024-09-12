<template>
    <table class="w-full text-left text-sm text-gray-700 rtl:text-right">
        <thead class="bg-gray-100 text-xs uppercase text-gray-700">
            <slot name="tableHead" />
        </thead>
        <tbody>
            <slot name="tableBody" />
        </tbody>
    </table>
</template>
