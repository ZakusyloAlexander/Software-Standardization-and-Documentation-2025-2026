import React, { useEffect } from "react";
import ReactDOM from "react-dom";
import "./Modal.css";

/**
 * Reusable centered modal with backdrop and scroll lock.
 * @param {Object} props
 * @param {boolean} props.isOpen
 * @param {string} props.ariaLabel
 * @param {React.ReactNode} props.children
 * @param {string} [props.className] - Extra class on the dialog panel.
 * @param {boolean} [props.closeOnBackdrop=false]
 * @param {Function} [props.onClose]
 * @param {number} [props.zIndex=2000]
 */
export const Modal = ({
  isOpen,
  ariaLabel,
  children,
  className = "",
  closeOnBackdrop = false,
  onClose,
  zIndex = 2000,
}) => {
  useEffect(() => {
    if (!isOpen) return undefined;

    const previousOverflow = document.body.style.overflow;
    document.body.style.overflow = "hidden";

    const onKeyDown = (event) => {
      if (event.key === "Escape" && onClose) {
        onClose();
      }
    };

    window.addEventListener("keydown", onKeyDown);
    return () => {
      document.body.style.overflow = previousOverflow;
      window.removeEventListener("keydown", onKeyDown);
    };
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  const root = document.getElementById("modal-root");
  if (!root) return null;

  const handleBackdropClick = () => {
    if (closeOnBackdrop && onClose) {
      onClose();
    }
  };

  return ReactDOM.createPortal(
    <div
      className="app-modal-overlay app-modal-overlay--visible"
      style={{ zIndex }}
      role="presentation"
      onClick={handleBackdropClick}
    >
      <div
        className={`app-modal ${className}`.trim()}
        role="dialog"
        aria-modal="true"
        aria-label={ariaLabel}
        onClick={(event) => event.stopPropagation()}
      >
        {children}
      </div>
    </div>,
    root,
  );
};
