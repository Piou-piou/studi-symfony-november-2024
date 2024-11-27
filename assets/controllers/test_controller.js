import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['name', 'result']
    connect() {
    }

    fillResult() {
        this.resultTarget.innerText = this.nameTarget.value
    }
}
