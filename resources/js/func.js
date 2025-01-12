function setDateToToday(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.value = new Date().toISOString().split('T')[0];
    }
}