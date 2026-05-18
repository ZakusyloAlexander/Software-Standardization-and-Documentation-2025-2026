import React from "react";
import { Modal } from "./Modal/Modal.jsx";

/**
 * Portal modal shown when the player wins a round.
 * @param {Object} props
 * @param {boolean} props.isOpen
 * @param {Object} [props.stats]
 * @param {Function} [props.onReplay]
 * @param {Function} [props.onNext]
 */
export const ResultsModal = ({ isOpen, stats, onReplay, onNext }) => (
  <Modal isOpen={isOpen} ariaLabel="Round complete" zIndex={1500} className="app-modal--game">
    <h2>Гру завершено!</h2>
    <p>Час: {stats?.elapsed ?? "--:--"}</p>
    <p>Ходи: {stats?.moves ?? 0}</p>
    <p>Точність: {stats?.accuracy ?? 0}%</p>

    <div className="actions">
      <button type="button" className="btn-primary" onClick={onNext}>
        До таблиці результатів
      </button>
      <button type="button" className="btn-secondary" onClick={onReplay}>
        Повторити
      </button>
    </div>
  </Modal>
);
