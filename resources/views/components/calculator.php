<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://unpkg.com/vue@2.1.8/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.20.0/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vuex/2.1.1/vuex.js"></script>
    <title>Calculator</title>
    <link rel="stylesheet" href="/assets/css/calculator.css">
</head>
<body>
<template data-template="calculatorbutton">
    <div class="Calculator-button" v-bind:class="className"><span
                v-bind:class="['btest', button.icon ? button.icon : '']" v-if="button.children == null"
                v-text="button.text" @click.stop="emitAction($event, button)"></span><span
                v-for="childButton in button.children" v-bind:class="[childButton.className || ' btest ', 'btest']"
                v-text="childButton.text" @click.stop="emitAction($event, childButton)"></span></div>
</template>
<div class="App js-app" v-bind:style="{ opacity: appLoaded ? 1 : 0 }">
    <div class="Calculator">
        <header class="Calculator-header">
            <div class="Calculator-expressions"><span class="Calculator-expressionsOverflow"></span><span
                        class="Calculator-expressionsList">{{ expressionList }}</span></div>
            <div class="Calculator-operands"><span class="Calculator-currentOperand"
                                                   v-bind:class="{ 'has-error': error }"
                                                   v-bind:style="{ 'font-size': font.size, 'font-weight': font.weight }">{{ operand }}</span>
            </div>
        </header>
        <div class="Calculator-body">
            <div class="Calculator-buttonsContainer">
                <div v-for="button in buttons" is="calculatorbutton" v-bind:button="button">{{ button.children }}</div>
            </div>
        </div>
        <div class="Calculator-equals" @click.stop="$store.dispatch('showTotal', { explicit: true })">
            <div class="Calculator-equalsLine"></div>
            <div class="Calculator-equalsLine"></div>
        </div>
    </div>
</div>
<script src="/assets/js/pages/calculator.js"></script>
</body>
</html>