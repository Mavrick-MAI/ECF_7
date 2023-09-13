function selectDev(event) {
    console.log(event.value);
    let dev1Input = document.getElementsByName("dev1")[0];
    let dev2Input = document.getElementsByName("dev2")[0];
    let dev3Input = document.getElementsByName("dev3")[0];

    for (let option of dev1Input.options) {
        option.disabled = false
        if (option.value != 0 && (option.value == dev2Input.value || option.value == dev3Input.value)) {
            option.disabled = true
        }
    }
    for (let option of dev2Input.options) {
        option.disabled = false
        if (option.value != 0 && (option.value == dev1Input.value || option.value == dev3Input.value)) {
            option.disabled = true
        }
    }
    for (let option of dev3Input.options) {
        option.disabled = false
        if (option.value != 0 && (option.value == dev1Input.value || option.value == dev2Input.value)) {
            option.disabled = true
        }
    }
}
